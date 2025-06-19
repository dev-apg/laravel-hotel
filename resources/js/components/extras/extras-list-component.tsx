import { type Extra } from '@/types';
import ExtraComponent from './extra-component';

interface ExtrasListComponentProps {
    extras: Extra[];
}

export default function ExtrasListComponent({ extras }: ExtrasListComponentProps) {
    if (!extras?.length) return null;

    return (
        <div className="mt-2 space-y-2 border-t pt-2">
            <p className="text-sm font-medium text-gray-700">Available Extras:</p>
            {extras.map((extra) => (
                <ExtraComponent key={`extra-${extra.id}`} extra={extra} />
            ))}
        </div>
    );
}
