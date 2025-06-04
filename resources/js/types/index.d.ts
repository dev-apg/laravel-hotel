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
    hotel: string | number | undefined;
    selectedDate: DateRange | undefined;
    adults: string | number | undefined;
    children: string | number | undefined;
}

export type BookingSetData = ReturnType<typeof useForm<BookingFormData>>['setData'];

export interface SearchData {
    hotel: number | null;
    checkin: string | null;
    checkout: string | null;
    adults: string | null;
    children: string | null;
}

export interface Hotel {
    id: number;
    name: string;
}

export interface RoomData {
    uuid: string;
    removable: boolean;
    adults: number;
    children: number;
}
