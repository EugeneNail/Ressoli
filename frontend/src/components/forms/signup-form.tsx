import Button from "../button/button";
import { Field } from "../custom-control/field";
import { FormProps } from "./form-props";

export class SignupFormErrors {
  name: string[] = [];
  lastName: string[] = [];
  email: string[] = [];
  password: string[] = [];
  passwordConfirmation: string[] = [];
}

type SignupFormProps = FormProps<SignupFormErrors, {}>;

export function SignupForm({ submit, errors }: SignupFormProps) {
  return (
    <form className="form" onSubmit={submit}>
      <h1 className="form__header">Signup</h1>
      <div className="form__input-group">
        <Field icon="person" label="Name" name="name" resetError={errors.reset} errors={errors.values.name} />
        <Field
          icon="person"
          label="Last Name"
          name="lastName"
          resetError={errors.reset}
          errors={errors.values.lastName}
        />
        <Field icon="mail" label="Email" name="email" resetError={errors.reset} errors={errors.values.email} />
        <Field
          icon="lock"
          label="Password"
          name="password"
          password
          resetError={errors.reset}
          errors={errors.values.password}
        />
        <Field
          icon="lock"
          label="Confirm Password"
          name="passwordConfirmation"
          password
          resetError={errors.reset}
          errors={errors.values.passwordConfirmation}
        />
      </div>
      <div className="form__button-group">
        <Button wide text="Signup" />
      </div>
      <p className="form__message">
        Already have an account?
        <a href="/login" className="form__link">
          Login
        </a>
      </p>
    </form>
  );
}
