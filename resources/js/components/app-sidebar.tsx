import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { SharedData, type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { LayoutGrid, ShoppingCart, Store } from 'lucide-react';
import AppLogoIcon from './app-logo-icon';

// const mainNavItems: NavItem[] = [
//     {
//         title: 'Dashboard',
//         href: '/dashboard',
//         icon: LayoutGrid,
//     },
// ];

const footerNavItems: NavItem[] = [
    // {
    //     title: 'Repository',
    //     href: 'https://github.com/laravel/react-starter-kit',
    //     icon: Folder,
    // },
    // {
    //     title: 'Documentation',
    //     href: 'https://laravel.com/docs/starter-kits#react',
    //     icon: BookOpen,
    // },
];

export function AppSidebar() {
    const { name, auth } = usePage<SharedData>().props;
    // const { branch } = useBranch();

    const mainNavItems: NavItem[] = [
        {
            title: 'Dashboard',
            href: '/dashboard',
            icon: LayoutGrid,
        },
        {
            title: 'Lojas',
            href: '/branches',
            icon: Store,
            visible: auth.isAdmin,
        },
        {
            title: 'Vendas',
            href: '/shopping/categories',
            icon: ShoppingCart,
            visible: auth.isAdmin,
        },
        // {
        //     title: 'Pedidos',
        //     href: branch ? `/orders/list/${branch}` : '/orders/list',
        //     icon: ShoppingBag,
        //     visible: auth.isAdmin || auth.isEmployee,
        // },
        // {
        //     title: 'Mesas',
        //     href: branch ? `/tables/${branch}` : '/tables',
        //     icon: HandPlatter,
        //     visible: auth.isAdmin || auth.isEmployee,
        // },
        // {
        //     title: 'Funcionários',
        //     href: branch ? `/employees/${branch}` : '/employees',
        //     icon: Contact,
        //     visible: auth.isAdmin,
        // },
        // {
        //     title: 'Configurações',
        //     href: '/settings/appearance',
        //     icon: Settings,
        //     visible: auth.isAdmin,
        // },
    ];
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={route('home')} className="relative z-20 flex items-center text-lg font-medium">
                                <AppLogoIcon className="me-2 max-h-10 w-12 fill-current text-black dark:text-white" />
                                {name}
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
