import * as React from "react";
import { cva, type VariantProps } from "class-variance-authority";
import { cn } from "@/lib/utils";

const buttonVariants = cva(
  "inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple disabled:pointer-events-none disabled:opacity-50",
  {
    variants: {
      variant: {
        default: "bg-brand-pink text-white hover:bg-brand-pink/90",
        secondary: "bg-brand-purple text-white hover:bg-brand-purple/90",
        destructive: "bg-red-600 text-white hover:bg-red-700",
        outline: "border border-slate-300 bg-white hover:bg-slate-50",
        ghost: "hover:bg-slate-100"
      },
      size: {
        default: "h-10 px-4 py-2",
        lg: "h-12 px-8 text-base",
        sm: "h-9 px-3"
      }
    },
    defaultVariants: {
      variant: "default",
      size: "default"
    }
  }
);

export interface ButtonProps
  extends React.ButtonHTMLAttributes<HTMLButtonElement>,
    VariantProps<typeof buttonVariants> {}

export function Button({ className, variant, size, ...props }: ButtonProps) {
  return (
    <button className={cn(buttonVariants({ variant, size, className }))} {...props} />
  );
}

export { buttonVariants };
