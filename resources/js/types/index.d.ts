export interface User {
    id: number;
    name: string;
    email: string;
    github_id: number;
    github_nickname: string;
    github_avatar: string;
    github_token: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
