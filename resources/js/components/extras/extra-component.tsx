import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { type Extra } from '@/types';

interface ExtraComponentProps {
    extra: Extra;
}

export default function ExtraComponent({ extra }: ExtraComponentProps) {
    const { id, name, description, selected } = extra;

    return (
        <div className="p-2">
            <div className="flex items-center gap-2">
                <Checkbox
                    id={`extra-${id}`}
                    checked={selected}
                    onCheckedChange={(checked) => {
                        console.log(checked);
                    }}
                />
                <Label htmlFor={`extra-${id}`} className="cursor-pointer text-lg">
                    {name}
                </Label>
            </div>
            <p className="ml-6 text-sm text-gray-600">{description}</p>
        </div>
    );
}
