import { FormEvent } from "react";
import { LoginForm, LoginFormErrors } from "../components/forms/login-form";
import { useErrors } from "../services/use-errors";
import api from "../services/api";
import { StorageUser } from "../models/storage-user";
import { useNavigate } from "react-router";

export function LoginPage() {
  const navigate = useNavigate();
  const errors = useErrors(new LoginFormErrors());

  async function login(event: FormEvent) {
    event.preventDefault();
    const payload = new FormData(event.target as HTMLFormElement);
    const { data, status } = await api.post("/login", payload);

    if (status === 200) {
      const user = new StorageUser();
      user.token = data;
      navigate("/dashboard");
    }

    if (status >= 400) {
      errors.set(data.errors);
      return;
    }
  }

  return (
    <div className="login-page">
      <LoginForm submit={login} errors={errors} />
    </div>
  );
}
