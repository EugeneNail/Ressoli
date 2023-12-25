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

  public static toShortDate(initialDate: Date): string {
    const date = new Date(initialDate);

    return `${date.getMonth() + 1}-${date.getDate()}-${date.getFullYear()}`;
  }
}
