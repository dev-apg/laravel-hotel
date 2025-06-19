import { type Extra } from '@/types';
import ExtraComponent from './extra-component';

interface ExtrasListComponentProps {
    extras: Extra[];
}

export default function ExtrasListComponent({ extras }: ExtrasListComponentProps) {
    return (
        <div>
            {extras.map((extra) => (
                <ExtraComponent key={extra.id} extra={extra} />
            ))}
        </div>
    );
}
