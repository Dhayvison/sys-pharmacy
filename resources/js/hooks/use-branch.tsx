import { useCallback, useEffect, useState } from 'react';

const setCookie = (name: string, value: string, days = 365) => {
    if (typeof document === 'undefined') {
        return;
    }

    const maxAge = days * 24 * 60 * 60;
    document.cookie = `${name}=${value};path=/;max-age=${maxAge};SameSite=Lax`;
};

export function useBranch() {
    const selectedBranchKey = 'selected_branch';
    const [branch, setBranch] = useState<number | null>(null);

    const selectBranch = useCallback((branchId: number) => {
        setBranch(branchId);

        // Store in localStorage for client-side persistence...
        localStorage.setItem(selectedBranchKey, `${branchId}`);

        // Store in cookie for SSR...
        setCookie(selectedBranchKey, `${branchId}`);
    }, []);

    useEffect(() => {
        const savedBranchId = localStorage.getItem(selectedBranchKey) as string | null;
        if (savedBranchId) {
            selectBranch(Number(savedBranchId));
        }
    }, [selectBranch]);

    return { branch, selectBranch } as const;
}
