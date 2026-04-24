import { NextResponse } from "next/server";
import { TaskStatus } from "@prisma/client";
import { prisma } from "@/lib/db";
import { getSession } from "@/lib/session";

function statusFromValue(value: unknown) {
  const normalized = String(value ?? "TODO").toUpperCase().replace("-", "");
  if (normalized === "DOING") return TaskStatus.DOING;
  if (normalized === "DONE") return TaskStatus.DONE;
  return TaskStatus.TODO;
}

export async function PUT(
  request: Request,
  { params }: { params: Promise<{ id: string }> }
) {
  const session = await getSession();
  if (!session) {
    return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  }

  const { id: taskId } = await params;
  const id = Number(taskId);
  const body = await request.json();
  const startAt = new Date(body.startAt);
  const dueAt = body.dueAt ? new Date(body.dueAt) : null;

  if (Number.isNaN(startAt.getTime())) {
    return NextResponse.json({ error: "Start date is required" }, { status: 400 });
  }

  if (dueAt && dueAt < startAt) {
    return NextResponse.json({ error: "Due date must be after start date" }, { status: 400 });
  }

  await prisma.task.updateMany({
    where: { id, userId: session.userId },
    data: {
      title: String(body.title ?? "").trim(),
      description: String(body.description ?? "").trim() || null,
      startAt,
      dueAt,
      status: statusFromValue(body.status),
      reminder: Boolean(body.reminder)
    }
  });

  return NextResponse.json({ ok: true });
}

export async function DELETE(
  _request: Request,
  { params }: { params: Promise<{ id: string }> }
) {
  const session = await getSession();
  if (!session) {
    return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  }

  const { id } = await params;
  await prisma.task.deleteMany({
    where: { id: Number(id), userId: session.userId }
  });

  return NextResponse.json({ ok: true });
}
