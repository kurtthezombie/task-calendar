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

export async function GET() {
  const session = await getSession();
  if (!session) {
    return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  }

  const tasks = await prisma.task.findMany({
    where: { userId: session.userId },
    orderBy: { startAt: "asc" }
  });

  return NextResponse.json(
    tasks.map((task) => ({
      id: String(task.id),
      title: task.title,
      start: task.startAt,
      end: task.dueAt,
      extendedProps: {
        description: task.description,
        status: task.status,
        reminder: task.reminder
      }
    }))
  );
}

export async function POST(request: Request) {
  const session = await getSession();
  if (!session) {
    return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  }

  const body = await request.json();
  const startAt = new Date(body.startAt);
  const dueAt = body.dueAt ? new Date(body.dueAt) : null;

  if (Number.isNaN(startAt.getTime())) {
    return NextResponse.json({ error: "Start date is required" }, { status: 400 });
  }

  if (dueAt && dueAt < startAt) {
    return NextResponse.json({ error: "Due date must be after start date" }, { status: 400 });
  }

  const task = await prisma.task.create({
    data: {
      title: String(body.title ?? "").trim(),
      description: String(body.description ?? "").trim() || null,
      startAt,
      dueAt,
      status: statusFromValue(body.status),
      reminder: Boolean(body.reminder),
      userId: session.userId
    }
  });

  return NextResponse.json({ id: task.id });
}
