import { SessionResponse } from "@/app/types/session";
import { apiFetch } from "./api";

const STORAGE_KEY = "auth_session";

const LOGIN_PATH = "TODO";
const LOGOUT_PATH = "TODO";
const ME_PATH = "TODO";

export async function login(email: string, password: string) {
  const res = await apiFetch<{ success: boolean }>(LOGIN_PATH, {
    method: "POST",
    body: JSON.stringify({ email, password }),
  });

  localStorage.setItem(STORAGE_KEY, "true");
  return res;
}

export async function logout() {
  await apiFetch<{ success: boolean }>(LOGOUT_PATH, {
    method: "POST",
  });

  localStorage.removeItem(STORAGE_KEY);
}

export async function getMe(): Promise<SessionResponse> {
  return apiFetch<SessionResponse>(ME_PATH, {
    method: "GET",
  });
}

export function isAuthenticated() {
  return localStorage.getItem(STORAGE_KEY) === "true";
}
