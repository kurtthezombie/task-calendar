import Link from "next/link";
import { Button } from "@/components/ui/button";
import { Card, CardBody } from "@/components/ui/card";
import { requireAdmin } from "@/lib/session";

export default async function AdminPage() {
  await requireAdmin();

  return (
    <main className="container mx-auto mt-12 px-4 text-center">
      <h1 className="text-6xl font-light">Welcome, Admin.</h1>
      <p className="mt-3 text-xl text-slate-600">Admin page of the task calendar system</p>
      <hr className="my-8" />
      <p className="mb-4">Options</p>
      <Card className="mx-auto max-w-3xl">
        <CardBody>
          <div className="flex justify-center gap-3">
            <Link href="/admin/users">
              <Button>Users</Button>
            </Link>
            <Link href="/admin/reports">
              <Button className="bg-yellow-500 hover:bg-yellow-600">Reports</Button>
            </Link>
          </div>
          <form action="/logout" method="post" className="mt-12">
            <Button variant="destructive" type="submit">
              Log out
            </Button>
          </form>
        </CardBody>
      </Card>
    </main>
  );
}
