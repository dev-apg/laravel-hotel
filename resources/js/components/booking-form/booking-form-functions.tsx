import { RoomData, RoomsAction } from '@/types';
import { RoomType } from './enums';

export const familyRoomTypes = [RoomType.family];
export const singleRoomTypes = [RoomType.single, RoomType.double, RoomType.accesible];
export const dualRoomTypes = [RoomType.double, RoomType.twin, RoomType.accesible];

export function newRoomData(removable = true): RoomData {
    const uuid = self.crypto.randomUUID();
    return {
        uuid,
        removable,
        type: RoomType.double,
        typeList: singleRoomTypes,
        adults: 1,
        children: 0,
    };
}

export function roomsReducer(rooms: RoomData[], action: RoomsAction): RoomData[] {
    if (action.type == 'add_room') {
        return [...rooms, newRoomData()];
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
                if (target.children > 0) {
                    target.typeList = familyRoomTypes;
                    target.type = RoomType.family;
                } else {
                    target.typeList = dualRoomTypes;
                    target.type = RoomType.double;
                }
            }
            break;
        case 'remove_adult':
            if (target.adults == 2) {
                target.adults = target.adults - 1;
                if (target.children > 0) {
                    target.typeList = familyRoomTypes;
                    target.type = RoomType.family;
                } else {
                    target.typeList = singleRoomTypes;
                    target.type = RoomType.double;
                }
            }
            break;
        case 'add_child':
            if (target.children <= 1) {
                target.children = target.children + 1;
                target.typeList = familyRoomTypes;
                target.type = RoomType.family;
            }
            break;
        case 'remove_child':
            if (target.children > 0) {
                target.children = target.children - 1;
                if (target.children == 0) {
                    if (target.adults == 2) {
                        target.typeList = dualRoomTypes;
                        target.type = RoomType.double;
                    } else {
                        target.typeList = singleRoomTypes;
                        target.type = RoomType.double;
                    }
                }
            }
            break;
        case 'update_room_type':
            if (action.payload?.type) {
                target.type = action.payload.type;
            }
            break;
        default:
            throw new Error(`action type '${action.type}' not found`);
            break;
    }

    return cloned;
}
