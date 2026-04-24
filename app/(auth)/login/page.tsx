import bcrypt from "bcryptjs";
import Link from "next/link";
import { redirect } from "next/navigation";
import { Button } from "@/components/ui/button";
import { Card, CardBody } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { prisma } from "@/lib/db";
import { createSession, getCurrentUser } from "@/lib/session";

async function login(formData: FormData) {
  "use server";

  const email = String(formData.get("email") ?? "").trim().toLowerCase();
  const password = String(formData.get("password") ?? "");
  const user = await prisma.user.findUnique({ where: { email } });

  if (!user || !(await bcrypt.compare(password, user.passwordHash))) {
    redirect("/login?error=Invalid%20email%20or%20password");
  }

  await createSession({ userId: user.id, role: user.role });
  redirect(user.role === "ADMIN" ? "/admin" : "/calendar");
}

export default async function LoginPage({
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
      <Card className="mx-auto max-w-xl">
        <CardBody className="p-10">
          <h1 className="mb-10 mt-3 text-4xl font-bold">Login</h1>
          <form action={login} className="space-y-8">
            <div className="space-y-2">
              <Label htmlFor="email">Email Address</Label>
              <Input
                id="email"
                name="email"
                type="email"
                placeholder="✉ Type your email address"
                className="rounded-none border-0 border-b-4 py-6"
                required
              />
            </div>
            <div className="space-y-2">
              <Label htmlFor="password">Password</Label>
              <Input
                id="password"
                name="password"
                type="password"
                placeholder="🔒 Type your password"
                className="rounded-none border-0 border-b-4 py-6"
                required
              />
            </div>
            <div className="text-right">
              <span className="text-brand-pink">Forgot Password?</span>
            </div>
            <div className="text-center">
              <Button size="lg" className="w-1/2" type="submit">
                Login
              </Button>
            </div>
          </form>
          <div className="mt-4 text-center">
            <Link href="/signup" className="text-slate-500">
              Don&apos;t have an account yet?{" "}
              <span className="underline">Sign Up</span>
            </Link>
          </div>
        </CardBody>
      </Card>
    </main>
  );
}
