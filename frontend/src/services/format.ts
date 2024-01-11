import { Address } from "../models/address";

export class Format {
  public static toFullAddress({ number, unit, street, typeOfStreet, city, postalCode }: Address): string {
    let fullAddress = `${number} ${street} ${typeOfStreet}`;

    if (unit !== null && unit != "") {
      fullAddress += `, Apt ${unit}`;
    }
    fullAddress += `, ${city}`;

    if (postalCode !== null && postalCode != "") {
      fullAddress += `, ${postalCode}`;
    }

    return fullAddress;
  }

  public static toShortDate(initialDate: Date | number | string): string {
    const date = new Date(initialDate);
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, "0");
    const day = date.getDate().toString().padStart(2, "0");

    return `${year}-${month}-${day}`;
  }
}
