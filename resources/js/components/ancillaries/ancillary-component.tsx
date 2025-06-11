import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { type Ancillary } from '@/types';

interface AncillaryProps {
    ancillary: Ancillary;
}

export default function AncillaryComponent({ ancillary }: AncillaryProps) {
    const { id, name, description } = ancillary;
    return (
        <div className="p-2">
            <div className="flex items-center gap-2">
                <Label className="text-xl" htmlFor={id.toString()}>
                    {name}
                </Label>
                <Checkbox id={id.toString()} className="" />
            </div>
            <p>{description}</p>
        </div>
    );
}
