import bcrypt from "bcryptjs";
import Link from "next/link";
import { redirect } from "next/navigation";
import { ArrowLeft } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardBody } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { prisma } from "@/lib/db";
import { requireAdmin } from "@/lib/session";
import { isName } from "@/lib/validation";

async function updateUser(formData: FormData) {
  "use server";

  const id = Number(formData.get("id"));
  const firstName = String(formData.get("firstName") ?? "").trim();
  const lastName = String(formData.get("lastName") ?? "").trim();
  const password = String(formData.get("password") ?? "");

  if (!isName(firstName) || !isName(lastName) || !password) {
    redirect(`/admin/users/${id}/edit?error=Invalid%20user%20details`);
  }

  await prisma.user.update({
    where: { id },
    data: {
      firstName,
      lastName,
      passwordHash: await bcrypt.hash(password, 12)
    }
  });

  redirect("/admin/users");
}

export default async function EditUserPage({
  params,
  searchParams
}: {
  params: Promise<{ id: string }>;
  searchParams: Promise<{ error?: string }>;
}) {
  await requireAdmin();
  const routeParams = await params;
  const queryParams = await searchParams;
  const user = await prisma.user.findUnique({ where: { id: Number(routeParams.id) } });
  if (!user) {
    redirect("/admin/users");
  }

  return (
    <main className="container mx-auto mt-3 px-4 pt-12">
      {queryParams.error ? (
        <p className="mb-4 text-center text-lg font-semibold text-red-600">
          {queryParams.error}
        </p>
      ) : null}
      <Card className="mx-auto max-w-2xl">
        <Link href="/admin/users" className="mx-10 mt-8 inline-flex text-3xl text-brand-purple">
          <ArrowLeft />
        </Link>
        <CardBody className="p-10 pt-4">
          <h1 className="mb-10 text-3xl font-semibold">Edit User</h1>
          <form action={updateUser} className="space-y-4">
            <input type="hidden" name="id" value={user.id} />
            <Input name="firstName" defaultValue={user.firstName} className="rounded-none border-0 border-b-4" required />
            <Input name="lastName" defaultValue={user.lastName} className="rounded-none border-0 border-b-4" required />
            <Input name="email" type="email" defaultValue={user.email} className="rounded-none border-0 border-b-4" readOnly />
            <Input name="password" type="password" placeholder="Enter Password" className="rounded-none border-0 border-b-4" required />
            <div className="pt-4 text-center">
              <Button size="lg" type="submit">
                Save Changes
              </Button>
            </div>
          </form>
        </CardBody>
      </Card>
    </main>
  );
}
