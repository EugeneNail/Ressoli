import { Icon } from "../icon/icon";

type HelperTextProps = {
  errors: string[];
  text: string;
};

export function HelperText({ errors, text }: HelperTextProps) {
  return (
    <>
      {errors.map((error, index) => (
        <p key={index} className="control__helper-text">
          <Icon className="control__helper-icon" name="warning" />
          {error}
        </p>
      ))}
      {text && errors.length === 0 && (
        <p className="control__helper-text">
          <Icon className="control__helper-icon" name="info" />
          {text}
        </p>
      )}
    </>
  );
}
