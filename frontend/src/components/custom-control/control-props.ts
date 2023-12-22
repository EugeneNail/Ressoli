export type ControlProps = {
  label: string;
  name: string;
  initialValue?: string;
  icon: string;
  helperText?: string;
  resetError?: (name: string) => void;
  errors: string[];
};
