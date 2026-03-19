import { SessionResponse } from "@/app/types/session";

export const sessionMock: SessionResponse = {
  user: {
    id: 1,
    name: "Bryan",
    email: "admin@demo.com",
  },
  company: {
    id: 1,
    name: "Polaris Demo",
    slug: "polaris-demo",
  },
};