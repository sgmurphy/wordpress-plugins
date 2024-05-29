import React from 'react';
import LighthouseCheckItem from '../lighthouse-check-item';
import { __, sprintf } from '@wordpress/i18n';
import { createInterpolateElement } from '@wordpress/element';
import LighthouseUtil from '../utils/lighthouse-util';
import Notice from '../../notices/notice';
import LighthouseTag from '../lighthouse-tag';
import LighthouseTable from '../tables/lighthouse-table';

export default class LighthouseCheckImageAlt extends React.Component {
	static defaultProps = {
		id: 'image-alt',
	};

	render() {
		return (
			<LighthouseCheckItem
				id={this.props.id}
				successTitle={__(
					'Image elements have [alt] attributes',
					'smartcrawl-seo'
				)}
				failureTitle={__(
					'Image elements do not have [alt] attributes',
					'smartcrawl-seo'
				)}
				successDescription={this.successDescription()}
				failureDescription={this.failureDescription()}
				copyDescription={() => this.copyDescription()}
				actionButton={LighthouseUtil.editHomepageButton()}
			/>
		);
	}

	commonDescription() {
		return (
			<React.Fragment>
				<div className="wds-lh-section">
					<strong>{__('Overview', 'smartcrawl-seo')}</strong>
					<p>
						{__(
							'Informative elements should aim for short, descriptive alternate text. Decorative elements can be ignored with an empty alt attribute.'
						)}
					</p>
				</div>
			</React.Fragment>
		);
	}

	successDescription() {
		return (
			<React.Fragment>
				{this.commonDescription()}
				<div className="wds-lh-section">
					<strong>{__('Status', 'smartcrawl-seo')}</strong>
					<Notice
						type="success"
						icon="sui-icon-info"
						message={__(
							'Way to go! It appears all your images have alt image text.',
							'smartcrawl-seo'
						)}
					/>
				</div>
			</React.Fragment>
		);
	}

	failureDescription() {
		return (
			<React.Fragment>
				{this.commonDescription()}
				<div className="wds-lh-section">
					<strong>{__('Status', 'smartcrawl-seo')}</strong>
					<Notice
						type="warning"
						icon="sui-icon-info"
						message={createInterpolateElement(
							__(
								"We've detected some of your images are missing <strong>alt tag</strong> text.",
								'smartcrawl-seo'
							),
							{
								strong: <strong />,
							}
						)}
					/>

					{this.renderTable()}
				</div>

				<div className="wds-lh-section">
					<strong>
						{__(
							'How to add alternative text to images',
							'smartcrawl-seo'
						)}
					</strong>
					<p>
						{__(
							'Provide an alt attribute for every <img> element. If the image fails to load, the alt text is used as a placeholder so users have a sense of what the image was trying to convey.',
							'smartcrawl-seo'
						)}
					</p>

					<ul>
						<li style={{ margin: '25px 0' }}>
							{__(
								'Most images should have short, descriptive text:',
								'smartcrawl-seo'
							)}
							<br />
							<div
								className="wds-lh-highlight"
								style={{ marginTop: '10px', border: 'none' }}
							>
								<LighthouseTag
									tag="img"
									attributes={{
										alt: __(
											'Audits set-up in Chrome DevTools ',
											'smartcrawl-seo'
										),
										src: '...',
									}}
								/>
							</div>
						</li>

						<li style={{ marginBottom: '25px' }}>
							{__(
								'If the image acts as decoration and does not provide any useful content, give it an empty alt="" attribute to remove it from the accessibility tree:',
								'smartcrawl-seo'
							)}
							<br />
							<div
								className="wds-lh-highlight"
								style={{ marginTop: '10px', border: 'none' }}
							>
								<LighthouseTag
									tag="img"
									attributes={{
										alt: '',
										src: 'background.png',
									}}
								/>
							</div>
						</li>
					</ul>

					<p>
						{createInterpolateElement(
							__(
								'See also <a>Include text alternatives for images and objects</a>.',
								'smartcrawl-seo'
							),
							{
								a: (
									<a
										href="https://web.dev/labels-and-text-alternatives/#include-text-alternatives-for-images-and-objects"
										target="_blank"
										rel="noreferrer"
									/>
								),
							}
						)}
					</p>
				</div>
			</React.Fragment>
		);
	}

	renderTable() {
		return (
			<LighthouseTable
				id={this.props.id}
				header={[
					__('Failing Elements', 'smartcrawl-seo'),
					__('Selector', 'smartcrawl-seo'),
				]}
				rows={this.getRows()}
			/>
		);
	}

	copyDescription() {
		return (
			sprintf(
				// translators: %s: Device label.
				__('Tested Device: %s', 'smartcrawl-seo'),
				LighthouseUtil.getDeviceLabel()
			) +
			'\n' +
			__('Audit Type: Content audits', 'smartcrawl-seo') +
			'\n\n' +
			__(
				'Failing Audit: Image elements do not have [alt] attributes',
				'smartcrawl-seo'
			) +
			'\n\n' +
			__(
				"Status: We've detected some of your images are missing alt tag text.",
				'smartcrawl-seo'
			) +
			'\n\n' +
			this.getFlattenedDetails(
				[
					__('Failing Elements', 'smartcrawl-seo'),
					__('Selector', 'smartcrawl-seo'),
				],
				this.getRows()
			) +
			__('Overview:', 'smartcrawl-seo') +
			'\n' +
			__(
				'Informative elements should aim for short, descriptive alternate text. Decorative elements can be ignored with an empty alt attribute.',
				'smartcrawl-seo'
			) +
			'\n\n' +
			__(
				'For more information please check the SEO Audits section in SmartCrawl plugin.',
				'smartcrawl-seo'
			)
		);
	}

	getRows() {
		const items = LighthouseUtil.getRawDetails(this.props.id)?.items;

		const rows = [];

		if (items) {
			items.forEach((item) => {
				rows.push({
					cols: [item.node?.snippet, item.node?.selector],
					screenshot: item.node?.lhId,
				});
			});
		}

		return rows;
	}

	getFlattenedDetails(header, rows) {
		if (!rows.length) {
			return [];
		}

		const flattenedDetails = [];

		rows.forEach((row) => {
			row.cols.forEach((col, index) => {
				let colHeader = header[index];

				if (colHeader) {
					colHeader =
						colHeader === 'object' ? colHeader : colHeader + ': ';
				}
				flattenedDetails.push(colHeader + col);
			});
		});

		return flattenedDetails.join('\n') + '\n\n';
	}
}
