import { type Extra } from '@/types';
import ExtraComponent from './extra-component';

interface extrasListComponentProps {
    extras: Extra[];
}

export default function extrasListComponent({ extras }: extrasListComponentProps) {
    return (
        <div>
            {extras.map((extra) => (
                <ExtraComponent key={extra.id} extra={extra} />
            ))}
        </div>
    );
}
