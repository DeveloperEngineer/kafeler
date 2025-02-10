export interface ProductType {
    id: number;
    name: string;
    slug: string;
    price: number;
    description: string;
    image: string | null;
    categories: { id: number; name: string }[];
}
