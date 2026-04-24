import bcrypt from "bcryptjs";
import { PrismaClient, Role } from "@prisma/client";

const prisma = new PrismaClient();

async function main() {
  const passwordHash = await bcrypt.hash("admin", 12);

  await prisma.user.upsert({
    where: { email: "a@admin.tc" },
    update: {
      passwordHash,
      firstName: "Admin",
      lastName: "Strator",
      role: Role.ADMIN
    },
    create: {
      email: "a@admin.tc",
      passwordHash,
      firstName: "Admin",
      lastName: "Strator",
      role: Role.ADMIN
    }
  });
}

main()
  .then(async () => {
    await prisma.$disconnect();
  })
  .catch(async (error) => {
    console.error(error);
    await prisma.$disconnect();
    process.exit(1);
  });
