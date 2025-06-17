import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { type Extra } from '@/types';

interface ExtraComponentProps {
    extra: Extra;
}

export default function ExtraComponent({ extra }: ExtraComponentProps) {
    const { id, name, description } = extra;
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
