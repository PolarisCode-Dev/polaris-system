import { User } from "./user";
import { Company } from "./company";

export type SessionResponse = {
  user: User;
  company: Company;
};
