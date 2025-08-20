export function cellphoneMask(phone: string) {
    return phone
        .replace(/\D/g, '')
        .slice(0, 11)
        .replace(/^(\d)/, '($1')
        .replace(/(\d{2})(\d)/, '$1) $2')
        .replace(/(\d{5})(\d)/, '$1-$2');
}

export function postalCodeMask(postalCode: string) {
    return postalCode
        .replace(/\D/g, '')
        .slice(0, 8)
        .replace(/(\d{5})(\d)/, '$1-$2');
}

export function cnpjMask(cnpj: string) {
    return cnpj
        .replace(/\D/g, '')
        .slice(0, 14)
        .replace(/(\d{2})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d)/, '$1/$2')
        .replace(/(\d{4})(\d{1,2})$/, '$1-$2');
}
