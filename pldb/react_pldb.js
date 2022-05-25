'use strict';

const e = React.createElement;

class LikeButton extends React.Component {
  constructor(props) {
    super(props);
    this.state = { liked: false };
  }

  render() {
    if (this.state.liked) {
      return 'You liked this.';
    }

    return e(
      'button',
      { onClick: () => this.setState({ liked: true }) },
      'Like'
    );
  }
}
class resultsDiv extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      pldb: true,
      add_loc: false,
      add_prop: false,
      
      searched: false,

    }
  }
  render() {
    if (this.state) {

    }
    return e(
      'div',
    )
  }
}
const domContainer = document.querySelector('#react_pldb');
ReactDOM.render(e(LikeButton), domContainer);