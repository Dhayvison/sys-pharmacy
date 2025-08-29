import { getSuggestDescription } from '@/api/categories';
import HeadingSmall from '@/components/heading-small';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import ShoppingLayout from '@/layouts/shopping/layout';
import { Category, SharedData, type BreadcrumbItem } from '@/types';
import { Transition } from '@headlessui/react';
import { Head, useForm } from '@inertiajs/react';
import { useDebounce } from '@uidotdev/usehooks';
import { Pencil, Plus, Trash } from 'lucide-react';
import { Dispatch, FormEventHandler, SetStateAction, useEffect, useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Vendas',
        href: '/shopping',
    },
    {
        title: 'Categorias',
        href: '/shopping/categories',
    },
];

function CategoryFormDialog({
    category = null,
    setCategory = () => {},
}: {
    category?: Category | null;
    setCategory: Dispatch<SetStateAction<Category | null>>;
}) {
    const [generatingDescription, setGeneratingDescription] = useState(false);
    const [show, setShow] = useState(false);
    const { data, setData, post, put, errors, processing, recentlySuccessful, reset, clearErrors } = useForm({
        name: '',
        description: '',
    });
    const debouncedName = useDebounce(data.name, 2000);

    const onOpen = () => {
        reset();
        clearErrors();
        setCategory(null);
        setShow(true);
    };

    const onClose = () => {
        setCategory(null);
        setShow(false);
    };

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        if (category) {
            put(route('categories.update', { id: category.id }), {
                preserveScroll: true,
                onSuccess: () => onClose(),
            });
        } else {
            post(route('categories.store'), {
                preserveScroll: true,
                onSuccess: () => onClose(),
            });
        }
    };

    useEffect(() => {
        if (category) {
            reset();
            clearErrors();
            setData('name', category.name);
            setData('description', category.description ?? '');

            setShow(true);
        }
    }, [clearErrors, category, reset, setData]);

    useEffect(() => {
        if (debouncedName && !category) {
            (async () => {
                setGeneratingDescription(true);
                const response = await getSuggestDescription(debouncedName);
                setData('description', response.data.description);
                setGeneratingDescription(false);
            })();
        }
    }, [debouncedName, setData, category]);

    return (
        <Dialog
            open={show}
            onOpenChange={(open) => {
                if (!open) {
                    console.log(open);
                    onClose();
                }
            }}
        >
            <DialogTrigger asChild onClick={() => onOpen()}>
                <Button>
                    Cadastrar categoria <Plus />
                </Button>
            </DialogTrigger>
            <DialogContent>
                <DialogTitle>{category ? 'Editar categoria' : 'Cadastrar categoria'}</DialogTitle>
                <DialogDescription>Preencha o nome da categoria e uma breve descrição (opcional).</DialogDescription>

                <form onSubmit={submit} className="grid gap-4">
                    <div className="grid gap-2">
                        <Label htmlFor="name" required>
                            Nome da Categoria
                        </Label>
                        <Input id="name" className="mt-1 block w-full" value={data.name} onChange={(e) => setData('name', e.target.value)} />
                        <InputError className="mt-2" message={errors.name} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="description">Descrição da Categoria</Label>

                        <Input
                            id="description"
                            type="text"
                            className="mt-1 block w-full"
                            value={data.description}
                            onChange={(e) => setData('description', e.target.value)}
                            autoComplete="off"
                            placeholder="Adicione uma descrição para a categoria"
                        />

                        {generatingDescription && <p className="animate-pulse text-xs text-blue-700">Gerando sugestão de descrição...</p>}

                        <InputError className="mt-2" message={errors.description} />
                    </div>

                    <div className="flex items-center gap-4">
                        <Button disabled={processing}>Salvar</Button>

                        <Transition
                            show={recentlySuccessful}
                            enter="transition ease-in-out"
                            enterFrom="opacity-0"
                            leave="transition ease-in-out"
                            leaveTo="opacity-0"
                        >
                            <p className="text-sm font-bold text-green-600 dark:text-green-400">Categoria salva com sucesso!</p>
                        </Transition>
                    </div>
                </form>
            </DialogContent>
        </Dialog>
    );
}

export default function Categories({ categories }: SharedData<{ categories: Category[] }>) {
    const [deleting, setDeleting] = useState<Category | null>(null);
    const [editing, setEditing] = useState<Category | null>(null);

    const { processing, delete: destroy } = useForm();

    const deleteCategory = () => {
        destroy(route('categories.destroy', { id: deleting?.id }), {
            preserveScroll: true,
            onSuccess: () => {
                setDeleting(null);
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Categorias" />

            <ShoppingLayout>
                <Dialog open={!!deleting} onOpenChange={() => setDeleting(null)}>
                    <DialogContent>
                        <DialogTitle>Deletar categoria "{deleting?.name}"</DialogTitle>
                        <DialogDescription>Tem certeza que deseja deletar o registro selecionado?</DialogDescription>
                        <form onSubmit={deleteCategory}>
                            <DialogFooter className="gap-2">
                                <DialogClose asChild>
                                    <Button variant="secondary" onClick={() => setDeleting(null)}>
                                        Cancelar
                                    </Button>
                                </DialogClose>

                                <Button variant="destructive" disabled={processing} asChild>
                                    <button type="submit">Deletar categoria</button>
                                </Button>
                            </DialogFooter>
                        </form>
                    </DialogContent>
                </Dialog>

                <div className="space-y-6">
                    <HeadingSmall title="Categorias" description="Organize os produtos da loja em categorias" />

                    <div className="grid gap-2">
                        {categories.map((category) => (
                            <div key={category.id} className="flex items-center justify-between gap-4 rounded-md border p-4 shadow-sm">
                                <div>
                                    <h3 className="text-lg font-semibold">{category.name}</h3>
                                    <p className="text-sm text-muted-foreground">{category.description}</p>
                                </div>

                                <div className="grid shrink-0 grid-cols-2 gap-2">
                                    <Button disabled={processing} size={'icon'} variant={'destructive'} onClick={() => setDeleting(category)}>
                                        <Trash />
                                    </Button>
                                    <Button disabled={processing} size={'icon'} variant={'secondary'} onClick={() => setEditing(category)}>
                                        <Pencil />
                                    </Button>
                                </div>
                            </div>
                        ))}
                    </div>

                    <div className="sticky bottom-4 gap-4 rounded-lg bg-accent p-4 shadow">
                        <div className="flex items-center justify-between gap-4">
                            <small className="text-sm text-gray-800 dark:text-gray-300">{categories.length} categoria(s) cadastrada(s)</small>

                            <CategoryFormDialog category={editing} setCategory={setEditing} />
                        </div>
                    </div>
                </div>
            </ShoppingLayout>
        </AppLayout>
    );
}
