import { Button } from '@/components/ui/button';
import { Popover, PopoverTrigger } from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import { PopoverContent } from '@radix-ui/react-popover';
import { useState } from 'react';

export default function Rooms_OLD() {
    const [rooms, setRooms] = useState([{ key: 1, adults: 2, children: 0 }]);

    const roomsTotal = rooms.length;
    const adultsTotal = rooms.reduce((acc, el) => {
        return acc + el.adults;
    }, 0);
    const childrenTotal = rooms.reduce((acc, el) => {
        return acc + el.children;
    }, 0);

    function handleAddRoom() {
        console.log(self.crypto.randomUUID());
        setRooms([...rooms, { key: rooms.length + 1, adults: 1, children: 0 }]);
    }

    function handleAddAdult() {}

    return (
        <Popover>
            <PopoverTrigger asChild>
                <Button id="date" variant={'outline'} className={cn('justify-start text-left font-normal')}>
                    Rooms: {roomsTotal} Adults: {adultsTotal} {childrenTotal > 0 && `ChildrenTotal: ${childrenTotal}`}
                </Button>
            </PopoverTrigger>
            <PopoverContent className="w-auto p-0" align="start">
                <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                    {rooms.map((room) => (
                        <div key={room.key} className="bg-red-500">
                            <div onClick={() => {}}>Adults: {room.adults}</div>
                            <div>Children: {room.children}</div>
                        </div>
                    ))}
                </div>
                {rooms.length < 6 && <Button onClick={handleAddRoom}>Add Room</Button>}
            </PopoverContent>
        </Popover>
    );
}
