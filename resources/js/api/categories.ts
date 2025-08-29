import api from './api';

export interface GetCartResponse {
    message: string;
    data: {
        description: string;
    };
}

export const getSuggestDescription = async (name: string): Promise<GetCartResponse> => {
    const response = await api.post('/categories/suggest-description', { name });
    return response.data;
};
