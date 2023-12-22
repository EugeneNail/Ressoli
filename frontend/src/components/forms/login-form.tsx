import Button from "../button/button";
import { Field } from "../custom-control/field";
import { FormProps } from "./form-props";
import "./form.sass";

export class LoginFormErrors {
  email: string[] = [];
  password: string[] = [];
}

type LoginFormProps = FormProps<LoginFormErrors, {}>;

export function LoginForm({ submit, errors }: LoginFormProps) {
  return (
    <form className="form" onSubmit={submit}>
      <h1 className="form__header">Login</h1>
      <div className="form__input-group">
        <Field icon="mail" label="Email" name="email" resetError={errors.reset} errors={errors.values.email} />
        <Field
          icon="lock"
          label="Password"
          name="password"
          password
          resetError={errors.reset}
          errors={errors.values.password}
        />
      </div>
      <div className="form__button-group">
        <Button wide text="Login" />
      </div>
      <p className="form__message">
        Don't have an account?
        <a href="/signup" className="form__link">
          Signup
        </a>
      </p>
    </form>
  );
}
