export default {
    credentialHtml(credential) {
        let text = '';

        switch (credential.type) {
            case 'employment':
                text = `
                    <i class="collection-item-radio-label-icon fa fa-briefcase" aria-hidden="true"></i>
                    <span class="collection-item-radio-label-content">
                        <span style="text-transform: capitalize;">
                            ${credential.property.position}
                        </span> at
                        <span style="text-transform: capitalize;">
                            ${credential.data.company_or_organization.name}
                        </span>
                        (${credential.property.start_year}-
                        ${credential.property.end_year ? credential.property.end_year : 'present'})
                    </span>`;
                break;
            case 'education':
                text = `
                    <i class="collection-item-radio-label-icon fa fa-graduation-cap" aria-hidden="true">
                    </i>
                    <span class="collection-item-radio-label-content">${credential.property.degree_type}
                    <span style="text-transform: capitalize;">
                        ${credential.data.concentration.name}
                    </span>
                    <span style="text-transform: capitalize;">
                        ${credential.data.secondary_concentration.name ?
                            `and ${credential.data.secondary_concentration.name}` : ''}
                    </span>
                    ${credential.property.graduation_year ?
                        ` (${credential.property.graduation_year})` : ''}</span>`;
                break;
            case 'location':
                text = `
                    <i class="collection-item-radio-label-icon fa fa-map-marker" aria-hidden="true"></i>
                    <span class="collection-item-radio-label-content">
                        <span>Lives in</span>
                        <span style="text-transform: capitalize;">${credential.data.location.name}</span>
                        <span>
                            <span>
                            (${credential.property.start_year} -
                            ${(credential.property.still_here || !credential.property.end_year) ?
                                'present' : ( credential.property.end_year) ?
                                credential.property.end_year : ''})
                            </span>
                        </span>
                    </span>
                    `;
                break;
            case 'topic':
                text = `
                    <i class="collection-item-radio-label-icon fa fa-futbol-o" aria-hidden="true"></i>
                    <span class="collection-item-radio-label-content">
                        <span>
                            ${credential.property.experience} .
                        </span>
                        <span style="text-transform: capitalize;">
                            ${credential.data.topic.name}
                        </span>
                    </span>`;
                break;
            default:
                break;
        }

        return text;
    },

    credentialText(credential) {
        let text = '';

        switch (credential.type) {
            case 'employment':
                text = `
                        ${credential.property.position} at
                        ${credential.data.company_or_organization.name}
                        (${credential.property.start_year}-
                        ${credential.property.end_year ? credential.property.end_year : 'present'})`;
                break;
            case 'education':
                text = `
                    ${credential.property.degree_type}
                    ${credential.data.concentration.name}
                    ${credential.data.secondary_concentration.name ?
                        `and ${credential.data.secondary_concentration.name}` : ''}
                    ${credential.property.graduation_year ?
                        ` (${credential.property.graduation_year})` : ''}`;
                break;
            case 'location':
                text = `
                    Lives in
                    ${credential.data.location.name}
                        (${credential.property.start_year} -
                        ${(credential.property.still_here || !credential.property.end_year) ?
                            'present' : ( credential.property.end_year) ?
                            credential.property.end_year : ''})
                    `;
                break;
            case 'topic':
                text = `
                    ${credential.property.experience}
                `;
                break;
            default:
                break;
        }

        return text;
    },

    answersCredentialHtml(credential) {
        let text = '';
        const helpers = Vue.prototype.$viender.helpers;

        switch (credential.type) {
            case 'employment':
                text = `
                    <span class="collection-item-radio-label-content">
                        <span style="text-transform: capitalize;">
                            ${credential.property.position}
                        </span> at
                        <a style="text-transform: capitalize;" href="${helpers.getUrl('self_html', credential.data.company_or_organization)}">
                            ${credential.data.company_or_organization.name}
                        </a>
                        (${credential.property.start_year}-
                        ${credential.property.end_year ? credential.property.end_year : 'present'})
                    </span>`;
                break;
            case 'education':
                text = `
                    </i>
                    <span class="collection-item-radio-label-content">${credential.property.degree_type}
                    <a style="text-transform: capitalize;" href="${helpers.getUrl('self_html', credential.data.concentration)}">
                        ${credential.data.concentration.name}
                    </a>
                    <a style="text-transform: capitalize;" href="${helpers.getUrl('self_html', credential.data.secondary_concentration)}">
                        ${credential.data.secondary_concentration.name ?
                            `and ${credential.data.secondary_concentration.name}` : ''}
                    </a>
                    ${credential.property.graduation_year ?
                        ` (${credential.property.graduation_year})` : ''}</span>`;
                break;
            case 'location':
                text = `
                    <span class="collection-item-radio-label-content">
                        <span>Lives in</span>
                        <a v-if="false" style="text-transform: capitalize;" href="${helpers.getUrl('self_html', credential.data.location)}">
                            ${credential.data.location.name}
                        </a>
                        <span>
                            <span>
                            (${credential.property.start_year} -
                            ${(credential.property.still_here || !credential.property.end_year) ?
                                'present' : ( credential.property.end_year) ?
                                credential.property.end_year : ''})
                            </span>
                        </span>
                    </span>
                    `;
                break;
            case 'topic':
                text = `
                    <span class="collection-item-radio-label-content">
                        <span>
                            ${credential.property.experience} .
                        </span>
                        <span style="text-transform: capitalize;">
                            ${credential.data.topic.name}
                        </span>
                    </span>`;
                break;
            default:
                break;
        }

        return text;
    },
};
