import { revalidatePath } from "next/cache";
import Link from "next/link";
import { Trash2 } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardBody } from "@/components/ui/card";
import { Table, Td, Th } from "@/components/ui/table";
import { prisma } from "@/lib/db";
import { requireAdmin } from "@/lib/session";

async function deleteUser(formData: FormData) {
  "use server";

  const id = Number(formData.get("id"));
  await prisma.user.delete({ where: { id } });
  revalidatePath("/admin/users");
}

export default async function UsersPage() {
  await requireAdmin();
  const users = await prisma.user.findMany({ orderBy: { id: "asc" } });

  return (
    <main className="container mx-auto mt-12 px-4 text-center">
      <h1 className="text-6xl font-light">Users</h1>
      <p className="mt-3 text-xl text-slate-600">These are the users of task calendar system</p>
      <hr className="my-8" />
      <Card>
        <CardBody>
          <Table>
            <thead>
              <tr>
                <Th>Seq#</Th>
                <Th>ID</Th>
                <Th>Email Address</Th>
                <Th>Firstname</Th>
                <Th>Lastname</Th>
                <Th>Role</Th>
                <Th>Change</Th>
                <Th>Delete</Th>
              </tr>
            </thead>
            <tbody>
              {users.map((user, index) => (
                <tr key={user.id}>
                  <Td>{index + 1}.</Td>
                  <Td>{user.id}</Td>
                  <Td>{user.email}</Td>
                  <Td>{user.firstName}</Td>
                  <Td>{user.lastName}</Td>
                  <Td>{user.role}</Td>
                  <Td>
                    <Link href={`/admin/users/${user.id}/edit`}>
                      <Button className="bg-cyan-500 hover:bg-cyan-600" size="sm">
                        Edit
                      </Button>
                    </Link>
                  </Td>
                  <Td>
                    <form action={deleteUser}>
                      <input type="hidden" name="id" value={user.id} />
                      <Button variant="outline" size="sm" type="submit">
                        <Trash2 className="h-4 w-4 text-red-600" />
                      </Button>
                    </form>
                  </Td>
                </tr>
              ))}
            </tbody>
          </Table>
          <div className="mt-6 text-left">
            <Link href="/admin">
              <Button variant="secondary">Back</Button>
            </Link>
          </div>
        </CardBody>
      </Card>
    </main>
  );
}
