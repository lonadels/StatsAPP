
import { observable, action } from 'mobx';

export default new class Counter {
  @observable count = 0;

  @action increase = () => {
    return ++this.count;
  }

  @action decrease = () => {
    return --this.count;
  }
}