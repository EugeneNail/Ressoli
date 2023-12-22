import { FormEvent } from "react";
import { useErrors } from "../services/use-errors";
import api from "../services/api";
import { StorageUser } from "../models/storage-user";
import { useNavigate } from "react-router";
import { SignupForm, SignupFormErrors } from "../components/forms/signup-form";

export function SignupPage() {
  const navigate = useNavigate();
  const errors = useErrors(new SignupFormErrors());

  async function signup(event: FormEvent) {
    event.preventDefault();
    const payload = new FormData(event.target as HTMLFormElement);
    const { data, status } = await api.post("/signup", payload);

    if (status === 201) {
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
    <div className="signup-page">
      <SignupForm submit={signup} errors={errors} />
    </div>
  );
}
