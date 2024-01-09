import { CardApartment } from "./card-apartment";
import { CardApplication } from "./card-application";
import { CardHouse } from "./card-house";
import { CardLandParcel } from "./card-land-parcel";

export type PaginatedApplicationCollection<A extends CardApartment | CardHouse | CardLandParcel> = {
  data: CardApplication<A>[];
  meta: {
    lastPage: number;
  };
};
