import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User | null;
    isAdmin: boolean;
    isEmployee: boolean;
    isClient: boolean;
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
    visible?: boolean;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export type SharedData<T extends Record<string, unknown> = Record<string, unknown>> = {
    name: string;
    logo: string;
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    selectedBranch: Branch | null;
    status: string | null | { title: string; description: string | null };
    success: string | null | { title: string; description: string | null };
    error: string | null | { title: string; description: string | null };
    [key: string]: unknown;
} & T;

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

export interface Branch {
    id: number;
    name: string;
    identifier: string;
    cnpj: string | null;
}
