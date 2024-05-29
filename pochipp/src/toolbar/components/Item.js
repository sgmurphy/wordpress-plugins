import { Button } from '@wordpress/components';
import { insert } from '@wordpress/rich-text';

const shops = {
	amazon: 'Amazon',
	rakuten: '楽天',
	yahoo: 'Yahoo',
	mercari: 'メルカリ',
};

const shortcodes = {
	button: 'pochipp_btn',
	link: 'pochipp_link',
	img: 'pochipp_img',
};

const generateCvkey = () => {
	const characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	const length = 8;
	return Array.from(Array(length))
		.map(() => characters[Math.floor(Math.random() * characters.length)])
		.join('');
};

const generateShortcode = (type, pid, title, cvKeyTag, shop) => {
	const shortcode = shortcodes[type];
	const shopLabel = shops[shop];
	switch (type) {
		case 'button':
			return `[${shortcode} id="${pid}" shop="${shop}"${cvKeyTag}]${shopLabel}[/${shortcode}]`;
		case 'link':
			return `[${shortcode} id="${pid}" shop="${shop}"${cvKeyTag}]${title}[/${shortcode}]`;
		case 'img':
			return `[${shortcode} id="${pid}" shop="${shop}"${cvKeyTag}]`;
		default:
			return '';
	}
};

export default ({
	selectedType, // "button" | "link" | "img"
	value,
	item,
	onChange,
	closePopover,
}) => {
	const { hasAffi } = window.pchppVars;
	const hasPro = window.pchppProVars !== undefined;
	const isAllHidden = hasAffi && Object.values(hasAffi).every((v) => v === '');
	const cvKeyTag = hasPro ? ` cvkey="${generateCvkey()}"` : '';

	return (
		<div className='pochipp-popover__card'>
			<div className='pochipp-popover__card-image'>
				<img src={item.image} width={100} height={100} alt='' />
			</div>
			<div className='pochipp-popover__card-body'>
				<p className='pochipp-popover__card-description'>{item.title}</p>
				<div className='pochipp-popover__card-btns'>
					{isAllHidden && (
						<div className='pochipp-popover__disabled'>
							<a href='https://pochipplocal.local/wp-admin/edit.php?post_type=pochipps&page=pochipp_settings&tab=basic'>
								ポチップ設定ページ
							</a>
							から、各ショップの「アフィリエイト設定」を行ってください。
						</div>
					)}
					{Object.entries(shops).map(([shop, label]) => {
						const showBtn = hasAffi && hasAffi[shop];

						return (
							showBtn && (
								<Button
									key={`btn-${shop}`}
									text={label}
									isSecondary
									onClick={() => {
										closePopover();
										onChange(
											insert(
												value,
												generateShortcode(selectedType, item.pid, item.title, cvKeyTag, shop),
												value.start,
												value.end
											)
										);
									}}
								/>
							)
						);
					})}
					{item.customBtnText && item.customBtnUrl && (
						<Button
							text={item.customBtnText}
							isSecondary
							onClick={() => {
								closePopover();
								onChange(
									insert(
										value,
										generateShortcode(selectedType, item.pid, item.title, cvKeyTag, 'custom1'),
										value.start,
										value.end
									)
								);
							}}
						/>
					)}
					{item.customBtnText2 && item.customBtnUrl2 && (
						<Button
							text={item.customBtnText2}
							isSecondary
							onClick={() => {
								closePopover();
								onChange(
									insert(
										value,
										generateShortcode(selectedType, item.pid, item.title, cvKeyTag, 'custom2'),
										value.start,
										value.end
									)
								);
							}}
						/>
					)}
				</div>
			</div>
		</div>
	);
};
