import bcrypt from "bcryptjs";
import Link from "next/link";
import { redirect } from "next/navigation";
import { ArrowLeft } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardBody } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { prisma } from "@/lib/db";
import { getCurrentUser } from "@/lib/session";
import { isName } from "@/lib/validation";

async function signup(formData: FormData) {
  "use server";

  const firstName = String(formData.get("firstName") ?? "").trim();
  const lastName = String(formData.get("lastName") ?? "").trim();
  const email = String(formData.get("email") ?? "").trim().toLowerCase();
  const password = String(formData.get("password") ?? "");
  const confirmPassword = String(formData.get("confirmPassword") ?? "");

  if (!isName(firstName) || !isName(lastName)) {
    redirect("/signup?error=Names%20must%20contain%20letters%20and%20spaces");
  }

  if (password !== confirmPassword) {
    redirect("/signup?error=Passwords%20do%20not%20match");
  }

  const existing = await prisma.user.findUnique({ where: { email } });
  if (existing) {
    redirect("/signup?error=Email%20is%20already%20registered");
  }

  await prisma.user.create({
    data: {
      firstName,
      lastName,
      email,
      passwordHash: await bcrypt.hash(password, 12)
    }
  });

  redirect("/login?error=Account%20successfully%20registered");
}

export default async function SignupPage({
  searchParams
}: {
  searchParams: Promise<{ error?: string }>;
}) {
  const params = await searchParams;
  const user = await getCurrentUser();
  if (user) {
    redirect(user.role === "ADMIN" ? "/admin" : "/calendar");
  }

  return (
    <main className="container mx-auto mt-3 px-4 pt-12">
      {params.error ? (
        <p className="mb-4 text-center text-lg font-semibold text-red-600">
          {params.error}
        </p>
      ) : null}
      <Card className="mx-auto max-w-2xl">
        <Link href="/login" className="mx-10 mt-8 inline-flex text-3xl text-brand-purple">
          <ArrowLeft />
        </Link>
        <CardBody className="p-10 pt-4">
          <h1 className="mb-10 text-3xl font-semibold">Sign Up</h1>
          <form action={signup} className="space-y-4">
            <Input name="firstName" placeholder="Enter First Name" className="rounded-none border-0 border-b-4" required />
            <Input name="lastName" placeholder="Enter Last Name" className="rounded-none border-0 border-b-4" required />
            <Input name="email" type="email" placeholder="Enter Email Address" className="rounded-none border-0 border-b-4" required />
            <Input name="password" type="password" placeholder="Enter Password" className="rounded-none border-0 border-b-4" required />
            <Input name="confirmPassword" type="password" placeholder="Re-enter Password" className="rounded-none border-0 border-b-4" required />
            <div className="pt-4 text-center">
              <Button size="lg" type="submit">
                CREATE ACCOUNT
              </Button>
            </div>
          </form>
        </CardBody>
      </Card>
    </main>
  );
}
