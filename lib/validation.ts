export function requireString(formData: FormData, key: string) {
  const value = String(formData.get(key) ?? "").trim();
  if (!value) {
    throw new Error(`${key} is required`);
  }

  return value;
}

export function parseOptionalDate(value: FormDataEntryValue | null) {
  const raw = String(value ?? "").trim();
  return raw ? new Date(raw) : null;
}

export function isName(value: string) {
  return /^[A-Za-z ]+$/.test(value.trim());
}
