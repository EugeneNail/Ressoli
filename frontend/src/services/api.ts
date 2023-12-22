import axios from "axios";
import { env } from "../env";

const api = axios.create({
  baseURL: env.API_URL,
  headers: {
    post: {
      Accept: "aplication/json",
    },
  },
  withCredentials: true,
});

api.interceptors.request.use((config) => {
  config.headers.Authorization = `Bearer ${localStorage.getItem("user_access_token")}`;
  return config;
});

api.interceptors.response.use(
  (response) => response,
  (error) => error.response
);

export default api;
