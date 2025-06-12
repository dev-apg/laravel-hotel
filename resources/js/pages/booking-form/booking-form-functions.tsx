import { RoomData, RoomsAction } from '@/types';

export function newRoomData(removable = true): RoomData {
    return { uuid: self.crypto.randomUUID(), removable, adults: 1, children: 0 };
}

export function roomsReducer(rooms: RoomData[], action: RoomsAction): RoomData[] {
    if (action.type == 'add_room') {
        return [...rooms, { uuid: self.crypto.randomUUID(), removable: true, adults: 1, children: 0 }];
    }

    if (action.type == 'reset') {
        return [newRoomData(false)];
    }

    let cloned = structuredClone(rooms);

    const target = cloned.find((room) => room.uuid == action.payload.uuid);

    if (!target) {
        return cloned;
    }

    switch (action.type) {
        case 'remove_room':
            if (target.removable) {
                cloned = cloned.filter((room) => room.uuid != target.uuid);
            }
            break;
        case 'add_adult':
            if (target.adults == 1) {
                target.adults = target.adults + 1;
            }
            break;
        case 'remove_adult':
            if (target.adults == 2) {
                target.adults = target.adults - 1;
            }
            break;
        case 'add_child':
            if (target.children == 0) {
                target.children = target.children + 1;
            }
            break;
        case 'remove_child':
            if (target.children > 0) {
                target.children = target.children - 1;
            }
            break;
        default:
            throw new Error('action type note found');
            break;
    }

    return cloned;
}
