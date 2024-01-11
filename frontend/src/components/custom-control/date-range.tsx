type DateRangeProps = {
  min: Date;
  max: Date;
  start: Date;
  end: Date;
  updateStart: (value: Date) => void;
  updateEnd: (value: Date) => void;
};
