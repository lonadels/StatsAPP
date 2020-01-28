
import { observable, action } from 'mobx';

export default class Counter {
  @observable count = 0;

  @action increase = () => {
    this.counter = ++this.count;
  }

  @action decrease = () => {
    this.counter = --this.count;
  }
}