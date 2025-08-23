import Heading from '@/components/heading';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { Branch, BreadcrumbItem, SharedData } from '@/types';
import { cnpjMask } from '@/utils/masks';
import { Transition } from '@headlessui/react';
import { Head, useForm } from '@inertiajs/react';
import { DialogClose } from '@radix-ui/react-dialog';
// import { LatLng, LatLngExpression, Map } from 'leaflet';
import { Pencil, Plus, Trash } from 'lucide-react';
import { Dispatch, FormEventHandler, SetStateAction, useEffect, useState } from 'react';
// import { MapContainer, Marker, TileLayer } from 'react-leaflet';

type BranchForm = {
    name: string;
    cnpj: string;
    identifier?: string;
};

// function MapPosition({ position, setPosition }: { position: LatLngExpression; setPosition: (position: LatLng) => void }) {
//     const [zoom, setZoom] = useState(20);
//     const [map, setMap] = useState<Map | null>(null);

//     const onMove = useCallback(() => {
//         const center = map?.getCenter();

//         if (center) {
//             setPosition(center);
//         }
//     }, [map, setPosition]);

//     useEffect(() => {
//         map?.on('move', onMove);
//         map?.on('zoom', () => {
//             setZoom(map.getZoom());
//         });
//         return () => {
//             map?.off('move', onMove);
//         };
//     }, [map, onMove]);

//     useEffect(() => {
//         map?.setView(position, zoom);
//     }, [map, position, zoom]);

//     return (
//         <MapContainer center={position} zoom={zoom} scrollWheelZoom={false} ref={setMap} className="h-40 rounded-xl">
//             <TileLayer
//                 attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
//                 url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
//             />
//             <Marker position={position}></Marker>
//         </MapContainer>
//     );
// }

function BranchFormDialog({ branch = null, setBranch = () => {} }: { branch?: Branch | null; setBranch: Dispatch<SetStateAction<Branch | null>> }) {
    const [show, setShow] = useState(false);
    const { data, setData, post, put, processing, errors, reset, clearErrors, recentlySuccessful } = useForm<BranchForm>({
        name: '',
        cnpj: '',
    });
    // const [isSearching, setIsSearching] = useState(false);
    // const debouncedPostalCode = useDebounce(data.postal_code, 500);

    const onOpen = () => {
        reset();
        clearErrors();
        setBranch(null);
        setShow(true);
        // loadCurrentLocation();
    };

    const onClose = () => {
        setBranch(null);
        setShow(false);
    };

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        if (branch) {
            put(route('branches.update', { id: branch.id }), {
                preserveScroll: true,
                onSuccess: () => onClose(),
            });
        } else {
            post(route('branches.store'), {
                preserveScroll: true,
                onSuccess: () => onClose(),
            });
        }
    };

    // const loadCurrentLocation = useCallback(() => {
    //     setIsSearching(true);
    //     console.log('loadCurrentLocation');

    //     if (navigator.geolocation) {
    //         navigator.geolocation.getCurrentPosition(
    //             (position) => {
    //                 console.log('position', position);
    //                 setData('latitude', position.coords.latitude.toString());
    //                 setData('longitude', position.coords.longitude.toString());
    //                 setIsSearching(false);
    //             },
    //             (error) => {
    //                 toast.error('Não foi possível obter a localização', { description: error.message });
    //                 setIsSearching(false);
    //             },
    //         );
    //     } else {
    //         toast.error('Geolocalização não é suportada pelo seu navegador');
    //     }
    // }, [setData]);

    // useEffect(() => {
    //     console.log('coords', data.latitude, data.longitude);
    // }, [data.latitude, data.longitude]);

    // useEffect(() => {
    //     if (debouncedPostalCode && debouncedPostalCode.length > 8 && debouncedPostalCode !== branch?.postal_code) {
    //         (async () => {
    //             setIsSearching(true);
    //             fetch(`https://brasilapi.com.br/api/cep/v2/${debouncedPostalCode}`)
    //                 .then((response) => response.json())
    //                 .then((responseData) => {
    //                     if (responseData.errors) {
    //                         toast.error('CEP não encontrado', { description: responseData.message });
    //                     } else {
    //                         setData('street', responseData.street ?? '');
    //                         setData('neighborhood', responseData.neighborhood ?? '');
    //                         setData('city', responseData.city ?? '');
    //                         setData('state', responseData.state ?? '');
    //                         if (responseData.location?.coordinates?.latitude && responseData.location?.coordinates?.longitude) {
    //                             setData('latitude', responseData.location.coordinates.latitude ?? '');
    //                             setData('longitude', responseData.location.coordinates.longitude ?? '');
    //                         }
    //                     }
    //                 })
    //                 .catch(() => {
    //                     console.error('Ops! 🙁', { description: `Ocorreu um erro ao pesquisar o CEP ${debouncedPostalCode}` });
    //                 })
    //                 .finally(() => {
    //                     setIsSearching(false);
    //                 });
    //         })();
    //     }
    // }, [branch?.postal_code, debouncedPostalCode, setData]);

    useEffect(() => {
        if (branch) {
            reset();
            clearErrors();
            setData({
                name: branch.name,
                cnpj: branch.cnpj ?? '',
            });

            setShow(true);
        }
    }, [clearErrors, branch, reset, setData]);

    return (
        <Dialog
            open={show}
            onOpenChange={(open) => {
                if (!open) {
                    onClose();
                }
            }}
        >
            <DialogTrigger asChild onClick={onOpen}>
                <Button>
                    Cadastrar loja <Plus />
                </Button>
            </DialogTrigger>
            <DialogContent>
                <DialogTitle>{branch ? 'Editar loja' : 'Cadastrar loja'}</DialogTitle>
                <DialogDescription>Cadastre as informações para que seus clientes identifiquem a unidade desejada</DialogDescription>

                <form onSubmit={submit} className="grid gap-4">
                    <div className="grid gap-2">
                        <Label htmlFor="name">Nome da unidade</Label>

                        <Input
                            id="name"
                            className="mt-1 block w-full"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            placeholder="Digite o nome da loja"
                        />

                        <InputError className="mt-2" message={errors.name} />
                    </div>

                    <div className="grid gap-2">
                        <Label>Identificador</Label>
                        <Input
                            className="pointer-events-none mt-1 block w-full"
                            value={data.name
                                .normalize('NFD')
                                .replace(/[\u0300-\u036f]/g, '') // remove accents
                                .replace(/[^a-zA-Z0-9]/g, '') // remove non-alphanumeric
                                .toLowerCase()}
                            readOnly
                            disabled
                        />
                        <InputError className="mt-2" message={errors.identifier} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="cnpj">CNPJ</Label>

                        <Input
                            id="cnpj"
                            className="mt-1 block w-full"
                            value={data.cnpj}
                            onChange={(e) => setData('cnpj', cnpjMask(e.target.value))}
                            placeholder="Digite o CNPJ da unidade"
                        />

                        <InputError className="mt-2" message={errors.cnpj} />
                    </div>

                    {/* <MapPosition
                        position={{ lat: Number(data.latitude), lng: Number(data.longitude) }}
                        setPosition={(position) => {
                            setData('latitude', position.lat.toString());
                            setData('longitude', position.lng.toString());
                        }}
                    /> */}

                    <div className="flex items-center gap-4">
                        <Button disabled={processing}>Salvar</Button>

                        <Transition
                            show={recentlySuccessful}
                            enter="transition ease-in-out"
                            enterFrom="opacity-0"
                            leave="transition ease-in-out"
                            leaveTo="opacity-0"
                        >
                            <p className="text-sm font-bold text-green-600 dark:text-green-400">Unidade salva com sucesso!</p>
                        </Transition>
                    </div>
                </form>
            </DialogContent>
        </Dialog>
    );
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lojas',
        href: '/branches',
    },
];

export default function Index({ branches }: SharedData<{ branches: Branch[] }>) {
    const [deleting, setDeleting] = useState<Branch | null>(null);
    const [editing, setEditing] = useState<Branch | null>(null);

    const { processing, delete: destroy } = useForm();

    const deleteTable = () => {
        destroy(route('branches.destroy', { id: deleting?.id }), {
            preserveScroll: true,
            onSuccess: () => {
                setDeleting(null);
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Lojas" />

            <Dialog open={!!deleting} onOpenChange={() => setDeleting(null)}>
                <DialogContent>
                    <DialogTitle>Remover loja "{deleting?.name}"</DialogTitle>
                    <DialogDescription>Tem certeza que deseja deletar o registro selecionado?</DialogDescription>
                    <form onSubmit={deleteTable}>
                        <DialogFooter className="gap-2">
                            <DialogClose asChild>
                                <Button variant="secondary" onClick={() => setDeleting(null)}>
                                    Cancelar
                                </Button>
                            </DialogClose>

                            <Button variant="destructive" disabled={processing} asChild>
                                <button type="submit">Remover loja</button>
                            </Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                {!branches.length ? (
                    <div className="flex flex-col items-center gap-8 rounded-2xl bg-accent p-8 text-center md:flex-row md:gap-0 md:text-left">
                        <img src={'/images/question.svg'} className="aspect-square w-full max-w-40 object-cover" />
                        <div>
                            <Heading title="Nenhuma loja cadastrada" description={'Cadastre e gerencie as unidades do seu negócio'} />
                        </div>
                    </div>
                ) : (
                    <div className="grid grid-cols-2 gap-4 lg:grid-cols-4">
                        {branches?.map((branch) => {
                            return (
                                <div key={branch.id} className={`flex flex-col overflow-hidden rounded-md border shadow-sm md:flex-row`}>
                                    <div className="relative grid flex-1 gap-2 p-4">
                                        <div className="line-clamp-3">
                                            <Heading title={branch.name} description={branch.cnpj ?? 'CNPJ não informado'} />
                                        </div>

                                        {/* <div>
                                            <CopyToClipboard
                                                value={route('menu.branch', { identifier: branch.identifier })}
                                                icon={Link}
                                                tooltip="Copiar link do cardápio"
                                            />
                                        </div> */}

                                        <div className="grid grid-cols-2 gap-2">
                                            <Button disabled={processing} size={'sm'} variant={'destructive'} onClick={() => setDeleting(branch)}>
                                                <Trash /> <span className="hidden md:inline">Deletar</span>
                                            </Button>
                                            <Button disabled={processing} size={'sm'} variant={'secondary'} onClick={() => setEditing(branch)}>
                                                <Pencil /> <span className="hidden md:inline">Editar</span>
                                            </Button>
                                        </div>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                )}

                <div className="sticky bottom-4 mt-auto rounded-lg bg-accent p-4 shadow">
                    <div className="flex items-center justify-between gap-4">
                        <small className="flex-1 text-sm">{branches.length} loja(s) cadastrada(s)</small>

                        <BranchFormDialog branch={editing} setBranch={setEditing} />
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
