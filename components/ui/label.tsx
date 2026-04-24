import * as React from "react";

export function Label(props: React.LabelHTMLAttributes<HTMLLabelElement>) {
  return <label className="text-sm font-bold uppercase tracking-wide text-slate-900" {...props} />;
}
