import {Component} from '@wordpress/element'

export class SilentErrorBoundary extends Component {

    constructor(props) {
        super(props);
        this.state = {hasError: false};
    }

    static getDerivedStateFromError(error) {
        return {hasError: true};
    }

    render() {
        if (this.state.hasError) {
            return null;
        }
        return this.props.children;
    }
}