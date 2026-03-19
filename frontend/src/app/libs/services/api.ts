export async function apiFetch<T>(
  path: string,
  options?: RequestInit,
): Promise<T> {
  const headers = new Headers(options?.headers);
  if (!headers.has("Content-Type")) {
    headers.set("Content-Type", "application/json");
  }

  const baseUrl = process.env.NEXT_PUBLIC_API_URL ?? process.env.API_URL ?? "";
  const res = await fetch(`${baseUrl}${path}`, {
    credentials: "include",
    ...options,
    headers,
  });

  if (!res.ok) {
    throw new Error("Request failed");
  }

  return (await res.json()) as T;
}
