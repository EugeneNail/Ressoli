import { FormEvent } from "react";
import { LoginForm, LoginFormErrors } from "../components/forms/login-form";
import { useErrors } from "../services/use-errors";
import { useNavigate } from "react-router";
import { useHttp } from "../services/useHttp";

export function LoginPage() {
  const navigate = useNavigate();
  const errors = useErrors(new LoginFormErrors());
  const http = useHttp();

  async function login(event: FormEvent) {
    event.preventDefault();
    const payload = new FormData(event.target as HTMLFormElement);
    const { data, status } = await http.post("/login", payload);

    if (status >= 400) {
      errors.set(data.errors);
      return;
    }

    if (status === 200) {
      localStorage.setItem("userId", data);
      navigate("/dashboard");
    }
  }

  return (
    <div className="login-page">
      <LoginForm submit={login} errors={errors} />
    </div>
  );
}
