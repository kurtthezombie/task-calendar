import { TaskCalendar } from "@/components/task-calendar";
import { Button } from "@/components/ui/button";
import { prisma } from "@/lib/db";
import { requireUser } from "@/lib/session";

export default async function CalendarPage() {
  const user = await requireUser();
  const tasks = await prisma.task.findMany({
    where: { userId: user.id },
    orderBy: { startAt: "asc" }
  });

  return (
    <main className="container mx-auto px-4 py-6">
      <div className="mb-6 flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-bold">Calendar</h1>
          <p className="text-slate-600">Welcome, {user.firstName}.</p>
        </div>
        <form action="/logout" method="post">
          <Button variant="destructive" type="submit">
            Logout
          </Button>
        </form>
      </div>
      <TaskCalendar
        initialTasks={tasks.map((task) => ({
          id: String(task.id),
          title: task.title,
          start: task.startAt.toISOString(),
          end: task.dueAt?.toISOString() ?? null,
          extendedProps: {
            description: task.description,
            status: task.status,
            reminder: task.reminder
          }
        }))}
      />
    </main>
  );
}
