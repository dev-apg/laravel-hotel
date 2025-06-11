import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface SearchRibbonProps {
    hotels: Hotel[];
    selected?: SearchData;
}

export interface BookingFormData {
    hotel_id: string | number | undefined;
    from: string | undefined;
    to: string | undefined;
    adults: string | number | undefined;
    children: string | number | undefined;
    rooms: number;
}

export type BookingSetData = ReturnType<typeof useForm<BookingFormData>>['setData'];

export interface Hotel {
    id: number;
    name: string;
    address_line_1: string;
    address_line_2: string;
    county: string;
    postcode: string;
}

export interface RoomData {
    uuid: string;
    removable: boolean;
    adults: number;
    children: number;
}

export interface RoomsAction {
    type: string;
    payload: RoomsPayload;
}

export interface RoomsPayload {
    uuid: string;
}

export type RoomAction =
    | { type: 'add_room' }
    | { type: 'remove_room'; payload: { uuid: string } }
    | { type: 'add_adult'; payload: { uuid: string } }
    | { type: 'remove_adult'; payload: { uuid: string } }
    | { type: 'add_child'; payload: { uuid: string } }
    | { type: 'remove_child'; payload: { uuid: string } }
    | { type: 'reset' };

export interface Ancillary {
    id: number;
    name: string;
    pricing_type: string;
    description: string;
}
