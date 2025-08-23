import { Button } from '@/components/ui/button';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import { useDebounce } from '@uidotdev/usehooks';
import { Check, ClipboardCheck, Copy, LucideIcon } from 'lucide-react';
import { createElement, useState } from 'react';

export default function CopyToClipboard({ value, icon = Copy, tooltip = 'Copiar' }: { value: string; icon?: LucideIcon; tooltip?: string }) {
    const [copied, setCopied] = useState(false);
    const [open, setOpen] = useState(false);
    const debouncedOpen = useDebounce(open, 300);

    return (
        <TooltipProvider>
            <Tooltip open={copied || debouncedOpen}>
                <TooltipTrigger asChild>
                    <Button
                        variant={'ghost'}
                        size={'icon'}
                        onClick={() => {
                            navigator.clipboard.writeText(value);
                            setCopied(true);
                            setTimeout(() => {
                                setCopied(false);
                            }, 3000);
                        }}
                        onMouseEnter={() => {
                            setOpen(true);
                        }}
                        onMouseLeave={() => setOpen(false)}
                    >
                        {copied ? <ClipboardCheck className="opacity-100 transition-opacity duration-500 starting:opacity-0" /> : createElement(icon)}
                    </Button>
                </TooltipTrigger>
                <TooltipContent>
                    {copied ? (
                        <span className="flex items-center gap-1">
                            Conteúdo copiado <Check className="ms-2" size={12} />
                        </span>
                    ) : (
                        <span>{tooltip}</span>
                    )}
                </TooltipContent>
            </Tooltip>
        </TooltipProvider>
    );
}
