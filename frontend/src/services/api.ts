import axios from "axios";
import { env } from "../env";

const api = axios.create({
  baseURL: env.API_URL,
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
  withCredentials: true,
});

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response.status === 401 && window.location.href != "/login") {
      window.location.href = "/login";
    }
    return error.response;
  }
);

export default api;
