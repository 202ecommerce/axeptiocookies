/// <reference types="vite/client" />
import type {Configuration, Language, Shop} from "./admin/js/src/types/types.ts";

declare global {
  interface Window {
    axeptiocookies: {
      translations: any;
      data: {
        configurations: Configuration[];
        languages: Language[];
        shops: {
          [key: number]: Shop;
        };
      };
      images: {
        create: string;
        list: string;
        people: string;
        sky: string;
        recommended: string;
      };
      links: {
        ajax: string;
        configuration: string;
        logo: string;
      };
    };
  }
}