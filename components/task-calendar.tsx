"use client";

import { useMemo, useState } from "react";
import FullCalendar from "@fullcalendar/react";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin, { DateClickArg } from "@fullcalendar/interaction";
import multiMonthPlugin from "@fullcalendar/multimonth";
import timeGridPlugin from "@fullcalendar/timegrid";
import { EventClickArg, EventInput } from "@fullcalendar/core";
import { Pencil, Trash2, X } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { displayDate, toLocalInputValue } from "@/lib/utils";

type CalendarTask = {
  id: string;
  title: string;
  start: string;
  end: string | null;
  extendedProps: {
    description: string | null;
    status: "TODO" | "DOING" | "DONE";
    reminder: boolean;
  };
};

type TaskForm = {
  id?: string;
  title: string;
  description: string;
  startAt: string;
  dueAt: string;
  status: "TODO" | "DOING" | "DONE";
  reminder: boolean;
};

const emptyForm: TaskForm = {
  title: "",
  description: "",
  startAt: "",
  dueAt: "",
  status: "TODO",
  reminder: true
};

export function TaskCalendar({ initialTasks }: { initialTasks: CalendarTask[] }) {
  const [tasks, setTasks] = useState(initialTasks);
  const [selectedTask, setSelectedTask] = useState<CalendarTask | null>(null);
  const [form, setForm] = useState<TaskForm>(emptyForm);
  const [mode, setMode] = useState<"create" | "edit" | null>(null);
  const [error, setError] = useState("");

  const events = useMemo<EventInput[]>(
    () =>
      tasks.map((task) => ({
        ...task,
        end: task.end ?? undefined
      })),
    [tasks]
  );

  function openCreate(startAt = "") {
    setError("");
    setForm({ ...emptyForm, startAt });
    setSelectedTask(null);
    setMode("create");
  }

  function openEdit(task: CalendarTask) {
    setError("");
    setForm({
      id: task.id,
      title: task.title,
      description: task.extendedProps.description ?? "",
      startAt: toLocalInputValue(task.start),
      dueAt: toLocalInputValue(task.end),
      status: task.extendedProps.status,
      reminder: task.extendedProps.reminder
    });
    setMode("edit");
  }

  function onDateClick(info: DateClickArg) {
    openCreate(`${info.dateStr}T00:00`);
  }

  function onEventClick(info: EventClickArg) {
    const task = tasks.find((item) => item.id === info.event.id) ?? null;
    setSelectedTask(task);
  }

  async function refreshTasks() {
    const response = await fetch("/api/tasks");
    setTasks(await response.json());
  }

  async function saveTask() {
    setError("");
    if (!form.title.trim() || !form.startAt) {
      setError("Title and start date are required.");
      return;
    }

    if (form.dueAt && new Date(form.dueAt) < new Date(form.startAt)) {
      setError("Due date must be after start date.");
      return;
    }

    const response = await fetch(form.id ? `/api/tasks/${form.id}` : "/api/tasks", {
      method: form.id ? "PUT" : "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(form)
    });

    if (!response.ok) {
      const body = await response.json();
      setError(body.error ?? "Unable to save task.");
      return;
    }

    await refreshTasks();
    setMode(null);
    setSelectedTask(null);
  }

  async function deleteTask(id: string) {
    if (!confirm("Are you sure you want to delete this task?")) {
      return;
    }

    await fetch(`/api/tasks/${id}`, { method: "DELETE" });
    await refreshTasks();
    setSelectedTask(null);
  }

  return (
    <>
      <FullCalendar
        plugins={[dayGridPlugin, interactionPlugin, multiMonthPlugin, timeGridPlugin]}
        height={900}
        timeZone="local"
        headerToolbar={{
          left: "today prev,next",
          center: "title",
          right: "dayGridMonth,timeGridWeek,multiMonthYear addTask"
        }}
        initialView="dayGridMonth"
        dayMaxEvents
        selectable
        events={events}
        eventClick={onEventClick}
        dateClick={onDateClick}
        customButtons={{
          addTask: {
            text: "+",
            click: () => openCreate(),
            hint: "Add Task"
          }
        }}
      />

      {selectedTask ? (
        <Modal title={selectedTask.title} onClose={() => setSelectedTask(null)}>
          <div className="space-y-5">
            <Detail label="Description" value={selectedTask.extendedProps.description || "No description"} />
            <Detail label="Start Date" value={displayDate(selectedTask.start)} />
            <Detail label="Due Date" value={displayDate(selectedTask.end)} />
            <Detail label="Status" value={selectedTask.extendedProps.status.replace("_", "-")} />
            <Detail label="Reminders" value={selectedTask.extendedProps.reminder ? "ON" : "OFF"} />
            <div className="flex justify-end gap-2">
              <Button type="button" onClick={() => openEdit(selectedTask)}>
                <Pencil className="mr-2 h-4 w-4" /> Edit
              </Button>
              <Button
                type="button"
                variant="destructive"
                onClick={() => deleteTask(selectedTask.id)}
              >
                <Trash2 className="mr-2 h-4 w-4" /> Delete
              </Button>
            </div>
          </div>
        </Modal>
      ) : null}

      {mode ? (
        <Modal title={mode === "create" ? "Create Task" : "Edit Task"} onClose={() => setMode(null)}>
          <div className="space-y-4">
            {error ? <p className="rounded bg-red-50 p-3 text-sm text-red-700">{error}</p> : null}
            <Input
              value={form.title}
              onChange={(event) => setForm({ ...form, title: event.target.value })}
              placeholder="Add Title"
              required
            />
            <Textarea
              value={form.description}
              onChange={(event) => setForm({ ...form, description: event.target.value })}
              placeholder="Add description"
            />
            <Field label="Start Date">
              <Input
                type="datetime-local"
                value={form.startAt}
                onChange={(event) => setForm({ ...form, startAt: event.target.value })}
              />
            </Field>
            <Field label="Due Date">
              <Input
                type="datetime-local"
                value={form.dueAt}
                onChange={(event) => setForm({ ...form, dueAt: event.target.value })}
              />
            </Field>
            <Field label="Status">
              <select
                className="h-10 w-full rounded-md border border-slate-300 px-3"
                value={form.status}
                onChange={(event) =>
                  setForm({ ...form, status: event.target.value as TaskForm["status"] })
                }
              >
                <option value="TODO">To-do</option>
                <option value="DOING">Doing</option>
                <option value="DONE">Done</option>
              </select>
            </Field>
            <div className="flex items-center justify-end gap-3">
              <span>Reminder:</span>
              <select
                className="h-10 rounded-md border border-slate-300 px-3"
                value={form.reminder ? "1" : "0"}
                onChange={(event) => setForm({ ...form, reminder: event.target.value === "1" })}
              >
                <option value="0">Off</option>
                <option value="1">On</option>
              </select>
              <Button type="button" onClick={saveTask}>
                {mode === "create" ? "Save" : "Save Changes"}
              </Button>
            </div>
          </div>
        </Modal>
      ) : null}
    </>
  );
}

function Modal({
  title,
  children,
  onClose
}: {
  title: string;
  children: React.ReactNode;
  onClose: () => void;
}) {
  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
      <div className="w-full max-w-lg rounded-lg bg-white shadow-card">
        <div className="flex items-center justify-between rounded-t-lg bg-brand-pink px-5 py-4">
          <h2 className="text-xl font-semibold text-white">{title}</h2>
          <button type="button" onClick={onClose} className="text-white">
            <X />
          </button>
        </div>
        <div className="p-6">{children}</div>
      </div>
    </div>
  );
}

function Field({ label, children }: { label: string; children: React.ReactNode }) {
  return (
    <label className="block space-y-1">
      <span className="text-sm font-medium">{label}</span>
      {children}
    </label>
  );
}

function Detail({ label, value }: { label: string; value: string }) {
  return (
    <div>
      <p className="text-sm font-semibold text-slate-500">{label}:</p>
      <p className="font-medium">{value}</p>
    </div>
  );
}
