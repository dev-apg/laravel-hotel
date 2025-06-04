import { format } from 'date-fns';
import { CalendarIcon } from 'lucide-react';

import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import { DateRange } from 'react-day-picker';

interface DatePickerProps {
    className: string | React.HTMLAttributes<HTMLDivElement>;
    date: DateRange | undefined;
    setDate: (date: DateRange | undefined) => void;
}

export default function DatePicker({ className, date, setDate }: DatePickerProps) {
    return (
        <div className={cn('grid gap-2', className)}>
            <Popover>
                <PopoverTrigger asChild>
                    <Button id="date" variant={'outline'} className={cn('justify-start text-left font-normal', !date && 'text-muted-foreground')}>
                        <CalendarIcon />
                        {date?.from ? (
                            date.to ? (
                                <>
                                    {format(date.from, 'LLL dd, y')} - {format(date.to, 'LLL dd, y')}
                                </>
                            ) : (
                                format(date.from, 'LLL dd, y')
                            )
                        ) : (
                            <span>Pick a date</span>
                        )}
                    </Button>
                </PopoverTrigger>
                <PopoverContent className="w-auto p-0" align="start">
                    <Calendar initialFocus mode="range" defaultMonth={date?.from} selected={date} onSelect={setDate} numberOfMonths={1} />
                </PopoverContent>
            </Popover>
        </div>
    );
}
