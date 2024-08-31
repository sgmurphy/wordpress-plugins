import { setCookie } from './setCookie';

export function deleteCookie(name) {
	setCookie(name, '', -1);
}
