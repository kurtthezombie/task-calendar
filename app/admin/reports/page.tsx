import Link from "next/link";
import { ArrowLeftCircle } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardBody } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Table, Td, Th } from "@/components/ui/table";
import { prisma } from "@/lib/db";
import { requireAdmin } from "@/lib/session";

export default async function ReportsPage({
  searchParams
}: {
  searchParams: Promise<{ email?: string }>;
}) {
  await requireAdmin();

  const params = await searchParams;
  const email = params.email?.trim().toLowerCase();
  const user = email
    ? await prisma.user.findUnique({
        where: { email },
        include: { tasks: { orderBy: { startAt: "asc" } } }
      })
    : null;

  return (
    <main className="container mx-auto mt-12 max-w-5xl px-4">
      <Link href="/admin">
        <Button variant="secondary">
          <ArrowLeftCircle className="mr-2 h-4 w-4" /> Back
        </Button>
      </Link>
      <h1 className="mt-4 text-6xl font-light">Reports</h1>
      <Card className="mt-6 border-brand-purple">
        <CardBody>
          <form className="mb-4 space-y-2">
            <label className="block text-sm font-medium">Email Address</label>
            <Input name="email" type="email" placeholder="Enter email" defaultValue={email} />
            <Button className="bg-yellow-500 hover:bg-yellow-600" type="submit">
              Search
            </Button>
          </form>

          {email && !user ? (
            <p className="text-3xl text-red-600">{email} does not exist or has no tasks.</p>
          ) : null}

          {user ? (
            <>
              <p className="mb-4 text-4xl font-light">{user.firstName}&apos;s tasks:</p>
              <Table>
                <thead>
                  <tr>
                    <Th>Seq#</Th>
                    <Th>Task Title</Th>
                    <Th>Task Description</Th>
                  </tr>
                </thead>
                <tbody>
                  {user.tasks.map((task, index) => (
                    <tr key={task.id}>
                      <Td>{index + 1}.</Td>
                      <Td>{task.title}</Td>
                      <Td>{task.description}</Td>
                    </tr>
                  ))}
                </tbody>
              </Table>
            </>
          ) : null}
        </CardBody>
      </Card>
    </main>
  );
}
