import PropTypes from "prop-types";
import styles from "./index.scss";

const Loader = ({loaderText}) => {
    return (
        <div className={styles.loaderContainer}>

            <h2 className={styles.loaderLogo}>
                PTH
            </h2>

            <span className={styles.loaderText}>
                {loaderText}
            </span>

        </div>
    )
}

Loader.defaultProps = {
    loaderText: "Loading.."
}

Loader.propTypes = {
    loaderText: PropTypes.string
}

export default Loader;