import { FormEvent } from "react";
import { useErrors } from "../services/use-errors";
import { useNavigate } from "react-router";
import { SignupForm, SignupFormErrors } from "../components/forms/signup-form";
import { useHttp } from "../services/useHttp";

export function SignupPage() {
  const navigate = useNavigate();
  const errors = useErrors(new SignupFormErrors());
  const http = useHttp();

  async function signup(event: FormEvent) {
    event.preventDefault();
    const payload = new FormData(event.target as HTMLFormElement);
    const { data, status } = await http.post("/signup", payload);

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
    <div className="signup-page">
      <SignupForm submit={signup} errors={errors} />
    </div>
  );
}
